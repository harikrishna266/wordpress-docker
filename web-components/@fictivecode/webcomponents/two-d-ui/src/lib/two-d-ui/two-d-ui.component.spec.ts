import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TwoDUiComponent } from './two-d-ui.component';

describe('TwoDUiComponent', () => {
  let component: TwoDUiComponent;
  let fixture: ComponentFixture<TwoDUiComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [TwoDUiComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(TwoDUiComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
